@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="hero">
            <h1>Pesan</h1>
        </div>
        <div class="notif">
            <h2>Pesan</h2>
        </div>

        {{-- Pesan Cards --}}
        <div class="pesan-card">
            <img alt="Profile picture of a person" height="50"
                src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg"
                width="50" />
            <div class="pesan-info">
                <h3>Hasan Basyri</h3>
                <p>Request pekerjaan membuat PPT.</p>
            </div>
            <button class="cek-button" onclick="openModal('{{ url('/notif/show_ajax') }}')">Cek</button>
        </div>

        <div class="pesan-card">
            <img alt="Profile picture of a person" height="50"
                src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg"
                width="50" />
            <div class="pesan-info">
                <h3>Fahmi Mardiansyah</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore.</p>
            </div>
            <button class="cek-button"
                onclick="openModal('Fahmi Mardiansyah', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')">Cek</button>
        </div>

        <!-- Tambahkan card lainnya dengan struktur yang sama -->

        {{-- Modal --}}
        <div id="modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3 id="modalTitle"></h3>
                <p id="modalMessage"></p>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('styles')
    <style>
        .cek-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .cek-button:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Function to open modal and display message
        function openModal(title, message) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modal').style.display = 'flex';
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
@endsection
