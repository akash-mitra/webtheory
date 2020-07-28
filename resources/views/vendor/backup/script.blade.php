#!/bin/bash

cd {{ base_path() }}
# SET BACKUP FILENAME & PATH
{{ $backupFileName = 'wt_backup_' . \Carbon\Carbon::parse(now())->format('Ymd') }}
{{ $backupFile = 'storage/backup/' . $backupFileName }}
echo "Backup File: {{ $backupFile }}.zip"

# echo {{ public_path('storage/media') }}
# echo {{ resource_path('views/active') }}
# echo {{ resource_path('views/templates') }}


# DATABASE BACKUP
@if ($db)
    rm -rf {{ base_path() . '/storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
    @if (env('DB_CONNECTION') == 'mysql')
        mysqldump -u {{ env('DB_USERNAME') }} -p{{ env('DB_PASSWORD') }} {{ env('DB_DATABASE') }} > {{ base_path() . '/storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
    @elseif (env('DB_CONNECTION') == 'pgsql')
        PGPASSWORD={{ env('DB_PASSWORD') }} pg_dump -h {{ env('DB_HOST') }} -p {{ env('DB_PORT') }} -U {{ env('DB_USERNAME') }} {{ env('DB_DATABASE') }} > {{ base_path() . '/storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
    @endif
@endif

# BACKUP CHOICE
{{ $directories = '' }}
@if($assets)
    {{ $directories .= ' public/storage/media ' }}
@endif
@if($templates)
    {{ $directories .= ' resources/views/active resources/views/templates ' }}
@endif
@if($db)
    {{ $directories .= ' storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql ' }}
@endif


# ADD DIRECTORIES TO ZIP
cd {{ base_path() }}
rm -rf {{ $backupFile }}.zip
# zip -r -q {{ $backupFile }} {{ 'public/storage/media' }} {{ 'resources/views/active' }} {{ 'resources/views/templates' }} {{ 'storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
zip -r -q {{ $backupFile }} {{ $directories }}
{{-- rm -rf {{ base_path() . '/storage/backup/' . env('DB_DATABASE') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }} --}}