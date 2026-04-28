<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Siap Export</title>
</head>

<body>
    <div class="my-5 mx-5">
        <a href="/jurnal-export-csv" target="_blank"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Export Data</a>
    </div>
    <div class="mb-5 mx-5">
        <table class="table w-full">
            <thead>
                <tr>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">No.</th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Laboratorium
                    </th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Dosen
                    </th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Program
                        Studi</th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Mata
                        Kuliah</th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Materi
                    </th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Tangal
                    </th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Jam
                        Mulai - Selesai</th>
                    <th scope="col"
                        class="px-3 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Jumlah
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $item)
                <tr class="bg-white">
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->labId->laboratorium }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->matkulId->dosen }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->programId->program }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->matkulId->matakuliah }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->materi }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->tanggal }}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->jam_mulai}} -{{ $item->jam_selesai}}
                    </td>
                    <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                        {{ $item->jumlah }}
                    </td>
                </tr>
                @empty
                <div class="bg-red-500 text-white p-3 rounded shadow-sm mb-3">
                    Data Belum Tersedia!
                </div>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>

</html>