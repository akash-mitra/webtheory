<div class="w-full">
    <div class="text-sm uppercase text-gray-500 my-4">Recent Pages</div>

    <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
        <table class="table-auto w-full">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="px-3 py-1 text-left">#</th>
                    <th class="px-3 py-1 text-left">Pages</th>
                    <th class="px-3 py-1 text-left">Created</th>
                </tr>
            </thead> 
            <tbody>
                @foreach ($data->recent_pages as $page)
                    <tr class="border-b">
                        <td class="px-3 py-1">{{ $loop->iteration }}</td>
                        <td class="px-3 py-1"><a href="/pages/{{ $page->id }}" class="text-blue-600">{{ $page->title }}</a></td>
                        <td class="px-3 py-1">{{ $page->updated_at->diffForHumans() }}</td>
                    </tr>
                    @if($loop->iteration > 4)
                        @break
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
<div>