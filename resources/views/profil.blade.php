@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div style="display: flex; justify-content: center; padding: 40px;">
    <div style="width: 100%; max-width: 700px;">

        {{-- Kotak Profil --}}
        <div style="padding: 24px; border: 1px solid #ccc; border-radius: 12px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 20px;">Profil Kamu</h3>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                @php
                $user = Auth::user();
                @endphp

                @foreach ([
                ['Nama Lengkap', $user->name],
                ['Email', $user->email],
                ['NIM',$user->nim],
                ['Tanggal Bergabung', $user->created_at->format('d M Y')],

                ] as [$label, $value])
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1; background: #e6f7ff; padding: 10px; border-radius: 6px; text-align: left;">
                        {{ $label }}
                    </div>
                    <div style="flex: 2; background: #f0f0f0; padding: 10px; border-radius: 6px; text-align: left;">
                        {{ $value }}
                    </div>
                </div>
                @endforeach
            </div>


        </div>
    </div>
</div>
@endsection