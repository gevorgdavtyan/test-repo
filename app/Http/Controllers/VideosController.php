<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    /** @var VideoService $videoService */
    private $videoService;

    private $paginate = 20;

    /**
     * VideosController constructor.
     * @param VideoService $videoService
     */
    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     *  Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::latest()->simplePaginate($this->paginate);
        return view('videos.index', compact('videos'))->with('1', (request()->input('page', 1) - 1) * $this->paginate);
    }


    public function search(Request $request)
    {
        /**
         * @TODO - to be implemented
         *
         */
        $name_starting = trim((string)$request->input('name_starting'));
        $name_ending = trim((string)$request->input('name_ending'));

        $request->validate([
            'name_starting' => 'required|min:2|max:20',
            'name_ending' => 'required|min:2|max:20',
        ]);

        $videos = $this->videoService->searchVideosByNameStartAndEnd($request->all());

        return view('videos.search', compact('videos', 'name_starting', 'name_ending'))->with('1', (request()->input('page', 1) - 1) * $this->paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @TODO - implement the logic to save the data
         */

        $result = $this->videoService->store_or_update($request, null);
        return redirect()->route('videos.index')->with($result['error'] ? 'error' : 'success', $result['message']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        /**
         * @TODO - implement the logic to save the data
         */

        $result = $this->videoService->store_or_update($request, $video->id);

        return redirect()->route('videos.index')->with($result['error'] ? 'error' : 'success', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('videos.index')->with('success', "Video deleted");
    }


}
