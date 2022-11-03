<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\ContentContract;
use App\Contracts\ParagraphContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\data;
use App\Http\Requests\ParagraphRequest;
use Illuminate\Http\Request;

class ParagraphController extends Controller
{
    protected ParagraphContract $paragraph;
    protected ContentContract $content;

    public function __construct(ParagraphContract $p,ContentContract $content)
    {
        $this->paragraph = $p;
        $this->content = $content;
        
    }

    public function create($content_id)
    {
        $content = $this->content->findOneById($content_id);
        return view('admin.contents.paragraphs.create',compact('content'));
    }

    public function store($content_id,ParagraphRequest $request)
    {
        $data = $request->validated();
        $content = $this->content->findOneById($content_id);
        $data['content_id'] = $content->id;
    
        $this->paragraph->new($data);
        session()->flash('success',__('messages.flash.create'));

        return to_route('admin.contents.show',$content_id);
    }

    public function edit($content_id,$paragraph_id)
    {
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        return view('admin.contents.paragraphs.edit',compact('paragraph'));
    }

    public function update($content_id,$paragraph_id,ParagraphRequest $request)
    {
         $data = $request->validated();
        
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);

    
        $this->paragraph->update($paragraph,$data);
        session()->flash('success',__('messages.flash.update')); 
        return to_route('admin.contents.show',$content_id); 
    }

    public function show($content_id,$paragraph_id)
    {
      
       
        
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        
        $text = str_replace("#shadowStart#", '<mark class=\"cdx-marker\">',$paragraph['text'] );
        $text = str_replace("#shadowEnd#", '</mark>', $text);
        
        $paragraph->text=$text;
          

        return view('admin.contents.paragraphs.show',compact('paragraph'));
    }

    public function updateContent($content_id,$paragraph_id,Request $request)
    {
        $data = $request->validate([
            'text' => 'required|array',
        ]);
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);

        $text = str_replace('<mark class=\"cdx-marker\">', "#shadowStart#", $data['text']);
        $text = str_replace('</mark>', "#shadowEnd#", $text); 
       /*  $paragraph->text=$text; */
        
        
        $this->paragraph->update($paragraph,[
            'text'=>$text
        ]
        );
        return response()->json([
            'success' => true,
            'paragraph' => $paragraph,
            'message' => __('messages.flash.update')
        ]);
    }


    public function destroy($content_id,$paragraph_id)
    {
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        $this->paragraph->destroy($paragraph);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.contents.show',$content_id);
    }


}
