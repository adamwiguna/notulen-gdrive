<?php

namespace App\Http\Controllers\User;

use DOMDocument;
use App\Models\Note;
use App\Models\User;
use App\Models\Photo;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NoteDistribution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Note::where('user_id', auth()->user()->id)->where('slug', null)->delete();

        $note = Note::create([
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('user.create-step-1.note', ['note' => $note]);
    }

    public function createStep1(Note $note)
    {
    //    dd($note->id);
        return view('user.note.create', ['note' => $note]);
    }

    public function storeStep1(Request $request, Note $note)
    {
        // dd($note);
        $validatedData = $request->validate([
            'slug' => "required|max:254|unique:notes,slug",
            'title' => "required|max:254",
            'organizer' => "required|max:254",
            'location' => "required|max:254",
            'date' => "required|max:254",
            'description' => "nullable|max:254",
            'content' => "required",
        ]);

        $note->update([
            'slug' => $note->slug??$request->slug,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'location' => $request->location,
            'date' => $request->date,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'position_id' => auth()->user()->position->id,
            // 'division_id' => auth()->user()->division->id,
            'organization_id' => auth()->user()->organization->id,
        ]);

        return redirect()->route('user.create-step-2.note', ['note' => $note]);

      
    }

    public function createStep2(Note $note)
    {
        return view('user.note.photo-create', ['note' => $note]);
    }
    

    public function storeStep2(Request $request, Note $note)
    {
        $request->validate([
            'photo' => 'mimes:jpeg,bmp,png,jpg|max:2048',
        ]);
        
        $ext = strtolower($request->photo->getClientOriginalExtension());
        $image_name = Str::random(50).'_'.time();
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'public/photos/'.$note->id.'/';
        $image_url = '/'.$upload_path.$image_full_name;
        $request->photo->move($upload_path, $image_full_name);
        
        $photo = new Photo;
        $photo->url = $image_url;
        $photo->note_id = $note->id;
        $photo->save();
       

        return redirect()->back();
    }

    public function destroyPhoto(Note $note, Photo $photo)
    {
        $photo->delete();
        File::delete(public_path($photo->url));
        session()->flash('message' , 'Foto berhasil dihapus');
        
        return redirect()->back();
    }
    
    public function createStep3(Note $note)
    {
        return view('user.note.attendance-create', ['note' => $note]);
    }

    public function storeStep3(Request $request, Note $note)
    {
        $request->validate([
            'name' => 'required|max:100',
            'position' => 'required|max:100',
            'organization' => 'required|max:100',
        ]);

        Attendance::create([
            'note_id' => $note->id,
            'name' => $request->name,
            'position' => $request->position,
            'organization' => $request->organization,
        ]);

        return redirect()->back();
    }

    public function destroyAttendance(Note $note, Attendance $attendance)
    {
        $attendance->delete();
        
        return redirect()->back();
    }

    public function createStep4(Note $note)
    {
        return view('user.note.share-create', ['note' => $note]);
    }

    public function complete(Note $note)
    {
        session()->flash('note-complete' , $note->title);
        return redirect()->route('user.dashboard');
    }


    public function store(Request $request)
    {
        // dd($request->body);
        $request->validate([
            'slug' => "required|max:254|unique:notes,slug",
            'title' => "required|max:254",
            'organizer' => "required|max:254",
            'location' => "required|max:254",
            'date' => "required|max:254",
            'description' => "nullable|max:254",
            'body' => "required",
        ]);

        $note = Note::create([
            'slug' => $request->slug,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'location' => $request->location,
            'date' => $request->date,
            'description' => $request->description,
            'content' => $request->body,
            'user_id' => auth()->user()->id,
            'position_id' => auth()->user()->position_id,
            // 'division_id' => auth()->user()->position->division_id,
            'organization_id' => auth()->user()->organization_id,
        ]);

        // $noteDistribution = NoteDistribution::create([
        //     'note_id' => $note->id,
        //     'sender_user_id' => auth()->user()->id,
        //     'receiver_user_id' => auth()->user()->id,
        // ]);

        
        session()->flash('message' , 'Notulen berhasil disimpan');

        
        return redirect()->route('user.photo.create', ['note' => $note]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        if (! Gate::allows('manage-this-note', $note)) {
            abort(403);
        }
        return view('user.note.edit', [
            'note' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        if (! Gate::allows('manage-this-note', $note)) {
            abort(403);
        }
  
        $request->validate([
            'title' => "required|max:254",
            'organizer' => "required|max:254",
            'location' => "required|max:254",
            'date' => "required|max:254",
            'description' => "nullable|max:254",
            'body' => "required",
        ]);

        $note->update([
            'title' => $request->title,
            'organizer' => $request->organizer,
            'location' => $request->location,
            'date' => $request->date,
            'description' => $request->description,
            'content' => $request->body,
            'user_id' => auth()->user()->id,
            'position_id' => auth()->user()->position->id,
            // 'division_id' => auth()->user()->division->id,
            'organization_id' => auth()->user()->organization->id,
        ]);

        
        session()->flash('message' , 'Notulen berhasil di-update');

        
        return redirect()->route('user.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();

        session()->flash('message' , 'Notulen berhasil dihapus');

        return redirect()->route('user.dashboard');
    }

    public function share(Note $note)
    {
        // dd($note);
        if (auth()->user()->is_admin || auth()->user()->position->can_share_note ) {
            $users = User::where('is_admin', false)
                            ->where('is_operator', false)
                            ->where('organization_id', auth()->user()->organization_id)
                            ->orWhereHas('position', function ($query)    {
                                $query->where('can_view_shared_note', true);
                            })
                            ->latest()->get();
        } else {
            $users = User::where('is_admin', false)
                            ->where('is_operator', false)
                            ->where('organization_id', auth()->user()->organization_id)
                            ->latest()->get();
        }

        return view('user.note.share', [
            'note' => $note,
            'users' => $users,
        ]);
    }

    public function export(Note $note)
    {
        // dd($note);

        $templateProcessing = new TemplateProcessor('word-template/note.docx');
        $templateProcessing->setValue('judul', strtoupper($note->title));
        $templateProcessing->setValue('keterangan', $note->description);
        $templateProcessing->setValue('pemimpin', $note->organizer);
        $templateProcessing->setValue('tanggal', $this->tanggal_indo($note->date, true));
        if (!$note->user) {
            $templateProcessing->setValue('penulis', 'Anonim');
        } else {
            $templateProcessing->setValue('penulis', $note->user->name);
        }

        foreach ($note->attendances as $attend) {
            $attendances[] = ['nama' => $attend->name];
        }
        $templateProcessing->cloneBlock('kehadiran', 0, true, false, $attendances);

        $value = $note->content;
        $wordTable = new \PhpOffice\PhpWord\Element\Table();
        $wordTable->addRow();
        $cell = $wordTable->addCell();                                
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell,$value);
                        
        $templateProcessing->setComplexBlock('pembahasan', $wordTable);
        
        
        $templateProcessing->saveAs($note->title. '.docx');
        return response()->download($note->title. '.docx')->deleteFileAfterSend(true);
    }

    public function export2(Note $note)
    {
        // dd($note);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
        $phpWord->setDefaultParagraphStyle(
            array(
                'align'      => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
                'spacing'    => 120,
                )
            );
        $section = $phpWord->addSection();
        
        $header = array('size' => 16, 'bold' => true);
        $phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
        $section->addText($note->title, $header, 'p2Style');

        $section->addTextBreak();

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1750)->addText("Penyelenggara");
        $table->addCell()->addText(": {$note->organizer}");
        $table->addRow();
        $table->addCell(1750)->addText("Tanggal");
        $table->addCell()->addText(": {$this->tanggal_indo($note->date, true)}");
        $table->addRow();
        $table->addCell(1750)->addText("Penulis");
        $table->addCell()->addText(": {$note->user->name} - {$note->organization->name}");

        $section->addTextBreak();

        $section->addLine(['weight' => 1, 'width' => 450, 'height' => 0]);
        $section->addText('Pembahasan:');
        $value = $note->content;
        $value = str_replace("<br><br>","<br/>",$value);
        $value = str_replace("<br>","</div><div>",$value);
        $html = $value;
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        // $doc = new DOMDocument();
        // $doc->loadHTML($note->content);
        // $doc->saveXML();
        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $doc->saveXml(), true);

        $section->addPageBreak();

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1,  'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, );
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18,  'bgColor' => 'EBEBEB');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);

        $section->addText('Daftar Kehadiran', $header, 'p2Style');
        
        $th = array('bold' => true);
        $section->addTextBreak();
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow();
        $table->addCell()->addText("No", $th);
        $table->addCell()->addText("Nama", $th);
        $table->addCell()->addText("Instansi", $th);
        $table->addCell()->addText("Jabatan", $th);
        $no = 1;
        foreach ($note->attendances as $key => $attendance) {
            $table->addRow();
            $table->addCell()->addText($key+1);
            $table->addCell()->addText($attendance->name);
            $table->addCell()->addText($attendance->organization);
            $table->addCell()->addText($attendance->position);
        }

       
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('notulen'.preg_replace('/[0-9\@\.\;\" "]+/', '', $note->title).'.docx');
        return response()->download('notulen'.preg_replace('/[0-9\@\.\;\" "]+/', '', $note->title).'.docx')->deleteFileAfterSend(true);
    }

    public static function tanggal_indo($tanggal, $cetak_hari = false)
    {
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }
}
