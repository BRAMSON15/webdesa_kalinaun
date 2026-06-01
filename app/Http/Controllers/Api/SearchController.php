<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchPengaduan(Request $request)
    {
        $results = $this->searchService->searchPengaduan($request->all());
        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    public function searchPenerimaBansos(Request $request)
    {
        $results = $this->searchService->searchPenerimaBansos($request->all());
        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    public function searchPengajuanSurat(Request $request)
    {
        $results = $this->searchService->searchPengajuanSurat($request->all());
        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    public function getFilterOptions(Request $request)
    {
        $type = $request->get('type', 'pengaduan');
        $options = $this->searchService->getFilterOptions($type);
        return response()->json([
            'success' => true,
            'options' => $options,
        ]);
    }
}
