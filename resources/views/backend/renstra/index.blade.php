@extends('layouts.app', ['title' => 'View Document'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Dokumen Renstra</h4>
        @can('admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRenstraModal">
            Upload Dokumen
        </button>
        @endcan
    </div>

    {{-- Tab navigasi dokumen --}}
    @if($allRenstra->count())
        <ul class="nav nav-pills mb-3" id="renstraList">
            @foreach($allRenstra as $item)
                <li class="nav-item me-2">
                    <a href="{{ route('backend.index.renstra', ['id' => $item->id]) }}" class="btn btn-outline-dark btn-sm">
                        📄 {{ $item->file }}
                    </a>
                    @can('admin')
                    <form action="{{ route('admin.backend.delete.document.renstra', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑</button>
                    </form>
                    @endcan
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Tampilkan via iframe --}}
    @if($renstra && $renstra->file)
    <div class="ratio ratio-16x9 mb-3">
        <iframe
            src="https://docs.google.com/gview?url={{ urlencode(asset('document/renstra/' . $renstra->file)) }}&embedded=true"
            frameborder="0">
        </iframe>
    </div>
    @endif

    {{-- Tampilkan isi via PHPSpreadsheet --}}
    @if(!empty($sheetsData))
        <h6>📑 Data Tabel (Mode Spreadsheet)</h6>
        <ul class="nav nav-tabs mb-3" id="sheetTab" role="tablist">
            @foreach($sheetsData as $sheetName => $rows)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $loop->index }}" data-bs-toggle="tab" data-bs-target="#sheet-{{ $loop->index }}" type="button" role="tab">
                        {{ $sheetName }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($sheetsData as $sheetName => $rows)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="sheet-{{ $loop->index }}">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            @foreach($rows as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Belum ada file yang diupload atau tidak dapat dibaca.</p>
    @endif

    {{-- Modal Upload --}}
    <div class="modal fade" id="createRenstraModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.backend.add.document.renstra') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Dokumen Renstra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File (.xls / .xlsx)</label>
                        <input class="form-control" type="file" name="file" id="file" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
