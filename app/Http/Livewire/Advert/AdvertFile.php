<?php

namespace App\Http\Livewire\Advert;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Advert\AdvertFile as AdvertFileModel;

class AdvertFile extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'editFile' => 'edit',
        'addFileEvent' => 'addFileEvent'
    ];

    public $filesNo = 0;
    public $files = null;
    public $editFile = null;
    public $audioFile = null;
    public $name = '';
    public $advert = null;

    public function mount()
    {
        if ($this->advert) {
            $this->files =  AdvertFileModel::latest()->where('advert_id', $this->advert['id'])->get();
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'audioFile' => 'required'
        ]);

        $file_name = substr($this->name, 0, 2) . '-' . time() . '.' . $this->audioFile->getClientOriginalExtension();

        AdvertFileModel::create([
            'name'      => $this->name,
            'file' => $file_name,
            'advert_id' => $this->advert['id']
        ]);

        // $this->file->move(public_path('adverts'), $file_name);

        $this->audioFile->storePubliclyAs('uploads', $file_name, 'adverts');
        $this->emit('newFileUploaded', $this->advert['id']);
        $this->name = '';
        $this->filesNo++;
        $this->mount();
        // $this->files =  AdvertFileModel::latest()->where('advert_id', $this->advert['id'])->get();
    }

    public function addFileEvent($advert)
    {
        $this->advert = $advert;
        $this->mount();
    }

    public function edit(AdvertFileModel $file)
    {
        // $file_path = $this->getFilePath($file['file']);

        $this->editFile = $file->id;
        $this->name = $file->name;
        // $this->audioFile = null;
        // $this->audioFile = $file_path;
    }

    public function update(AdvertFileModel $file)
    {
        $this->validate([
            'name' => 'required'
            // 'audioFile' => 'required'
        ]);

        if ($this->audioFile) {
            $this->checkDeleteFile($file->file);

            $file_name = substr($this->name, 0, 2) . '-' . time() . '.' . $this->audioFile->getClientOriginalExtension();
            $file->update([
                'name'      => $this->name,
                'file' => $file_name,
                'advert_id' => $this->advert['id']
            ]);

            $this->audioFile->storePubliclyAs('uploads', $file_name, 'adverts');
        } else {
            $file->update([
                'name'      => $this->name,
                'advert_id' => $this->advert['id']
            ]);
        }

        $this->emit('newFileUploaded', $this->advert['id']);
        $this->name = '';
        $this->audioFile = null;
        $this->mount();
        $this->filesNo++;
    }

    public function deleteFile(AdvertFileModel $file)
    {
        $this->checkDeleteFile($file->file);

        $file->delete();
        $this->files =  AdvertFileModel::latest()->where('advert_id', $this->advert['id'])->get();
        $this->emit('newFileUploaded', $this->advert['id']);
        $this->mount();
    }

    public function getFilePath($file_name)
    {
        return public_path('/adverts/uploads/' . $file_name);
    }

    public function checkDeleteFile($file_name)
    {
        $file_path = $this->getFilePath($file_name);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    public function filesAddFinished()
    {
        $this->emit('addScheduleEvent', $this->advert);
    }

    public function render()
    {
        return view('livewire.advert.advert-file');
    }
}
