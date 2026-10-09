<?php

namespace Tests\Feature;

use App\Models\PatientFile;
use App\Models\PatientFileBackup;
use App\Services\PatientFileBackupService;
use App\Services\PatientFileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PatientFilesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('medical_files');
        Storage::fake('medical_files_backup');
        // بنختبر منطق الملفات بس من غير ما نحتاج factories للدكتور والمريض.
        Schema::disableForeignKeyConstraints();
    }

    protected function tearDown(): void
    {
        Schema::enableForeignKeyConstraints();
        parent::tearDown();
    }

    private function pdf(int $kb = 6): UploadedFile
    {
        return UploadedFile::fake()->create('a.pdf', $kb, 'application/pdf');
    }

    public function test_quota_blocks_upload_and_saves_nothing(): void
    {
        config(['clinic.patient_files_storage_gb' => 0.00001]); // ~10 KB
        $s = app(PatientFileService::class);

        $s->store(1, 1, $this->pdf());

        try {
            $s->store(1, 1, $this->pdf());
            $this->fail('كان لازم يترفض');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('file', $e->errors());
        }

        $this->assertSame(1, PatientFile::count());
        $this->assertCount(1, Storage::disk('medical_files')->allFiles());
    }

    public function test_delete_frees_space_and_removes_file(): void
    {
        $s = app(PatientFileService::class);
        $f = $s->store(1, 1, $this->pdf());

        $this->assertGreaterThan(0, $s->usedBytes(1));
        $s->delete($f);

        $this->assertSame(0, $s->usedBytes(1));
        Storage::disk('medical_files')->assertMissing($f->stored_path);
    }

    public function test_backup_is_incremental(): void
    {
        $s = app(PatientFileService::class);
        $b = app(PatientFileBackupService::class);

        $s->store(1, 1, $this->pdf());
        $s->store(1, 1, $this->pdf());
        $this->assertSame(2, $b->run()->copied_count);

        $s->store(1, 1, $this->pdf());
        $run = $b->run();
        $this->assertSame(1, $run->copied_count);
        $this->assertSame('success', $run->status);
        $this->assertCount(3, Storage::disk('medical_files_backup')->allFiles());
    }

    public function test_backup_survives_delete_then_purges_after_30_days(): void
    {
        $s = app(PatientFileService::class);
        $b = app(PatientFileBackupService::class);

        $f = $s->store(1, 1, $this->pdf());
        $b->run();
        $s->delete($f);

        $this->assertNotNull(PatientFileBackup::first()->source_deleted_at);
        Storage::disk('medical_files_backup')->assertExists($f->stored_path);

        $this->travel(20)->days();
        $b->run();
        Storage::disk('medical_files_backup')->assertExists($f->stored_path);

        $this->travel(11)->days(); // 31 يوم من الحذف
        $b->run();
        Storage::disk('medical_files_backup')->assertMissing($f->stored_path);
        $this->assertSame(0, PatientFileBackup::count());
    }

    public function test_restore_brings_back_missing_primary_file(): void
    {
        $s = app(PatientFileService::class);
        $b = app(PatientFileBackupService::class);

        $f = $s->store(1, 1, $this->pdf());
        $b->run();
        Storage::disk('medical_files')->delete($f->stored_path); // محاكاة ضياع الـ Primary

        $b->restore(PatientFileBackup::first());

        Storage::disk('medical_files')->assertExists($f->stored_path);
    }
}
