<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Specialties = [

            [
                "name" => "الباطنة والقلب",
                "slug" => "internal-medicine",
                "title" => "تشخيص وعلاج أمراض الباطنة والقلب",
                "logo" => "fa-solid fa-heart-pulse",
                "sort_order" => 0,
            ],

            [
                "name" => "الأطفال",
                "slug" => "pediatrics",
                "title" => "رعاية الأطفال ومتابعة نموهم وصحتهم",
                "logo" => "fa-solid fa-child",
                "sort_order" => 0,
            ],

            [
                "name" => "الجراحة العامة",
                "slug" => "general-surgery",
                "title" => "تشخيص وعلاج الحالات التي تحتاج إلى تدخل جراحي",
                "logo" => "fa-solid fa-user-doctor",
                "sort_order" => 0,
            ],

            [
                "name" => "العظام",
                "slug" => "orthopedics",
                "title" => "علاج أمراض وإصابات العظام والمفاصل",
                "logo" => "fa-solid fa-bone",
                "sort_order" => 0,
            ],

            [
                "name" => "النساء والتوليد",
                "slug" => "obstetrics-gynecology",
                "title" => "رعاية صحة المرأة ومتابعة الحمل والولادة",
                "logo" => "fa-solid fa-person-pregnant",
                "sort_order" => 1,
            ],

            [
                "name" => "الجلدية",
                "slug" => "dermatology",
                "title" => "تشخيص وعلاج أمراض الجلد والشعر والأظافر",
                "logo" => "fa-solid fa-hand",
                "sort_order" => 0,
            ],

            [
                "name" => "العيون",
                "slug" => "ophthalmology",
                "title" => "فحص وعلاج أمراض العيون وتحسين صحة النظر",
                "logo" => "fa-solid fa-eye",
                "sort_order" => 1,
            ],

            [
                "name" => "الأنف والأذن والحنجرة",
                "slug" => "ent",
                "title" => "تشخيص وعلاج أمراض الأنف والأذن والحنجرة",
                "logo" => "fa-solid fa-ear-listen",
                "sort_order" => 0,
            ],

            [
                "name" => "الأسنان",
                "slug" => "dentistry",
                "title" => "العناية بصحة الأسنان واللثة وعلاج مشكلاتها",
                "logo" => "fa-solid fa-tooth",
                "sort_order" => 1,
            ],

            [
                "name" => "المخ والأعصاب",
                "slug" => "neurology",
                "title" => "تشخيص وعلاج أمراض المخ والأعصاب",
                "logo" => "fa-solid fa-brain",
                "sort_order" => 0,
            ],

            [
                "name" => "الطب النفسي",
                "slug" => "psychiatry",
                "title" => "تشخيص وعلاج الاضطرابات والمشكلات النفسية",
                "logo" => "fa-solid fa-head-side-virus",
                "sort_order" => 0,
            ],

            [
                "name" => "المسالك البولية",
                "slug" => "urology",
                "title" => "تشخيص وعلاج أمراض الجهاز البولي والمسالك",
                "logo" => "fa-solid fa-person",
                "sort_order" => 0,
            ],

            [
                "name" => "الكلى",
                "slug" => "nephrology",
                "title" => "تشخيص وعلاج أمراض الكلى ومتابعة وظائفها",
                "logo" => "fa-solid fa-filter",
                "sort_order" => 0,
            ],

            [
                "name" => "الجهاز الهضمي",
                "slug" => "gastroenterology",
                "title" => "تشخيص وعلاج أمراض الجهاز الهضمي والكبد",
                "logo" => "fa-solid fa-utensils",
                "sort_order" => 0,
            ],

            [
                "name" => "الصدر والجهاز التنفسي",
                "slug" => "pulmonology",
                "title" => "تشخيص وعلاج أمراض الجهاز التنفسي والصدر",
                "logo" => "fa-solid fa-lungs",
                "sort_order" => 0,
            ],

            [
                "name" => "الغدد الصماء والسكر",
                "slug" => "endocrinology",
                "title" => "تشخيص وعلاج أمراض الغدد والسكري واضطرابات الهرمونات",
                "logo" => "fa-solid fa-droplet",
                "sort_order" => 0,
            ],

            [
                "name" => "الروماتيزم",
                "slug" => "rheumatology",
                "title" => "تشخيص وعلاج أمراض الروماتيزم والمفاصل",
                "logo" => "fa-solid fa-bone",
                "sort_order" => 0,
            ],

            [
                "name" => "الأورام",
                "slug" => "oncology",
                "title" => "تشخيص وعلاج ومتابعة أمراض الأورام",
                "logo" => "fa-solid fa-ribbon",
                "sort_order" => 0,
            ],

            [
                "name" => "الأوعية الدموية",
                "slug" => "vascular-surgery",
                "title" => "تشخيص وعلاج أمراض الأوعية الدموية والشرايين",
                "logo" => "fa-solid fa-staff-snake",
                "sort_order" => 0,
            ],

            [
                "name" => "جراحة المخ والأعصاب",
                "slug" => "neurosurgery",
                "title" => "التدخل الجراحي لعلاج أمراض المخ والأعصاب",
                "logo" => "fa-solid fa-brain",
                "sort_order" => 0,
            ],

            [
                "name" => "جراحة القلب والصدر",
                "slug" => "cardiothoracic-surgery",
                "title" => "الجراحات المتخصصة للقلب والصدر",
                "logo" => "fa-solid fa-heart-pulse",
                "sort_order" => 0,
            ],

            [
                "name" => "جراحة الأطفال",
                "slug" => "pediatric-surgery",
                "title" => "العلاج الجراحي للحالات لدى الأطفال",
                "logo" => "fa-solid fa-child",
                "sort_order" => 0,
            ],

            [
                "name" => "جراحة التجميل",
                "slug" => "plastic-surgery",
                "title" => "الجراحات التجميلية والترميمية",
                "logo" => "fa-solid fa-wand-magic-sparkles",
                "sort_order" => 0,
            ],

            [
                "name" => "جراحة الوجه والفكين",
                "slug" => "maxillofacial-surgery",
                "title" => "علاج الحالات الجراحية للوجه والفكين والفم",
                "logo" => "fa-solid fa-face-smile",
                "sort_order" => 0,
            ],

            [
                "name" => "التخدير",
                "slug" => "anesthesiology",
                "title" => "التخدير والرعاية أثناء العمليات والإجراءات الطبية",
                "logo" => "fa-solid fa-syringe",
                "sort_order" => 0,
            ],

            [
                "name" => "الأشعة",
                "slug" => "radiology",
                "title" => "التشخيص باستخدام الأشعة والفحوصات التصويرية",
                "logo" => "fa-solid fa-x-ray",
                "sort_order" => 1,
            ],

            [
                "name" => "الطب الطبيعي والتأهيل",
                "slug" => "physical-medicine-rehabilitation",
                "title" => "التأهيل والعلاج الطبيعي وتحسين الحركة",
                "logo" => "fa-solid fa-person-walking",
                "sort_order" => 0,
            ],

            [
                "name" => "طب الأسرة",
                "slug" => "family-medicine",
                "title" => "رعاية صحية شاملة ومتابعة أفراد الأسرة",
                "logo" => "fa-solid fa-people-roof",
                "sort_order" => 0,
            ],

            [
                "name" => "طب الطوارئ",
                "slug" => "emergency-medicine",
                "title" => "التعامل مع الحالات الطبية والإصابات الطارئة",
                "logo" => "fa-solid fa-truck-medical",
                "sort_order" => 0,
            ],

            [
                "name" => "الطب الرياضي",
                "slug" => "sports-medicine",
                "title" => "الوقاية من الإصابات الرياضية وعلاجها وتأهيلها",
                "logo" => "fa-solid fa-person-running",
                "sort_order" => 0,
            ],

            [
                "name" => "التغذية العلاجية",
                "slug" => "clinical-nutrition",
                "title" => "خطط غذائية علاجية تناسب الحالات الصحية المختلفة",
                "logo" => "fa-solid fa-apple-whole",
                "sort_order" => 0,
            ],

            [
                "name" => "طب الشيخوخة",
                "slug" => "geriatrics",
                "title" => "الرعاية الصحية المتخصصة لكبار السن",
                "logo" => "fa-solid fa-person-cane",
                "sort_order" => 0,
            ],

            [
                "name" => "حديثي الولادة",
                "slug" => "neonatology",
                "title" => "رعاية ومتابعة الأطفال حديثي الولادة",
                "logo" => "fa-solid fa-baby",
                "sort_order" => 0,
            ],

            [
                "name" => "الحساسية والمناعة",
                "slug" => "allergy-immunology",
                "title" => "تشخيص وعلاج الحساسية واضطرابات المناعة",
                "logo" => "fa-solid fa-shield-virus",
                "sort_order" => 0,
            ],

            [
                "name" => "الأمراض المعدية",
                "slug" => "infectious-diseases",
                "title" => "تشخيص وعلاج الأمراض الناتجة عن العدوى",
                "logo" => "fa-solid fa-virus",
                "sort_order" => 0,
            ],

        ];

        DB::table("specialties")->upsert(
            $Specialties,
            ["slug"],
            ["name", "title", "logo", "sort_order"]
        );
    }
}
