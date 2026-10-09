<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ParsesDates;
use App\Http\Controllers\Controller;

use App\Models\FinanceEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreFinanceEntryRequest;
class FinanceController extends Controller
{
    use ParsesDates;

    public function index(Request $request)
    {

        $from = $this->dateOrNull($request->input('from')) ?? now()->startOfMonth()->toDateString();
        $to = $this->dateOrNull($request->input('to')) ?? now()->endOfMonth()->toDateString();
        $type = in_array($request->input('type'), ['income', 'expense'], true) ? $request->input('type') : null;
        $category = array_key_exists((string) $request->input('category'), FinanceEntry::allCategories()) ? $request->input('category') : null;
        $search = trim((string) $request->input('search', ''));

        $base = FinanceEntry::query()
            ->whereBetween('entry_date', [$from, $to])
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search !== '', fn ($q) => $q->where('title', 'like', '%' . addcslashes($search, '%_\\') . '%'));

        $income = (float) (clone $base)->where('type', 'income')->sum('amount');
        $expense = (float) (clone $base)->where('type', 'expense')->sum('amount');

        $byCategory = (clone $base)->selectRaw('type, category, SUM(amount) as total, COUNT(*) as n')
            ->groupBy('type', 'category')->orderByDesc('total')->get();

        $entries = (clone $base)->latest('entry_date')->latest('id')->paginate(15)->withQueryString();

        // آخر 6 شهور (بغض النظر عن الفلتر) للمقارنة.
        $months = FinanceEntry::query()
            ->selectRaw("DATE_FORMAT(entry_date, '%Y-%m') as ym")
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income")
            ->selectRaw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
            ->where('entry_date', '>=', now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('ym')->orderByDesc('ym')->get();

        return view('admin.finance.index', [
            'entries' => $entries, 'income' => $income, 'expense' => $expense, 'net' => $income - $expense,
            'byCategory' => $byCategory, 'months' => $months,
            'from' => $from, 'to' => $to, 'type' => $type, 'category' => $category, 'search' => $search,
            'categories' => FinanceEntry::CATEGORIES,
        ]);
    }



public function store(StoreFinanceEntryRequest $request): RedirectResponse
{
    $entry = FinanceEntry::create($request->validated() + ['created_by' => auth()->id()]);


    return back()->with('success', 'تم تسجيل الحركة.');
}

    public function destroy(FinanceEntry $entry): RedirectResponse
    {


        $entry->delete();

        return back()->with('success', 'تم حذف الحركة.');
    }
}
