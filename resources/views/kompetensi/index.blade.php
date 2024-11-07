@extends('layouts.template')

@section('content')
<div class="hero">
    <h1>Kompetensi Tugas</h1>
</div>
<div class="content">
    <div class="titles">
     Manage Kompetensi Tugas
    </div>
    <a class="add-task" href="#">
     + Tambah Kompetensi Tugas
    </a>
    <div class="jenis-card">
     <img alt="Profile picture of a person" height="50" src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg" width="50"/>
     <div class="jenis-info">
      <h3>
       CopyWriting
      </h3>
      <p>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.
      </p>
     </div>
     <div class="jenis-actions">
      <button class="edit-btn">
       Edit
      </button>
      <button class="delete-btn">
       Delete
      </button>
     </div>
    </div>
    <div class="jenis-card">
     <img alt="Profile picture of a person" height="50" src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg" width="50"/>
     <div class="jenis-info">
      <h3>
       Front-End
      </h3>
      <p>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.
      </p>
     </div>
     <div class="jenis-actions">
      <button class="edit-btn">
       Edit
      </button>
      <button class="delete-btn">
       Delete
      </button>
     </div>
    </div>
    <div class="jenis-card">
     <img alt="Profile picture of a person" height="50" src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg" width="50"/>
     <div class="jenis-info">
      <h3>
       Back-End
      </h3>
      <p>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.
      </p>
     </div>
     <div class="jenis-actions">
      <button class="edit-btn">
       Edit
      </button>
      <button class="delete-btn">
       Delete
      </button>
     </div>
    </div>
</div>
@endsection