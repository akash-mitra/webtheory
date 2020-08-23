#!/bin/bash

# REMOVE OLD FILES IF ANY
rm -rf {{ base_path() . '/storage/backup/*.sql' }}
rm -rf {{ base_path() . '/storage/backup/*.zip' }}


cd {{ base_path() }}
# SET BACKUP FILENAME & PATH
{{ $backupFileName = 'wt_backup_' . \Carbon\Carbon::parse(now())->format('Ymd') }}
{{ $backupFile = 'storage/backup/' . $backupFileName }}
echo "Backup File: {{ $backupFile }}.zip"


# DATABASE BACKUP
@if ($db)

    @if (config('database.default') == 'pgsql')
        rm -rf {{ base_path() . '/storage/backup/' . config('database.connections.pgsql.database') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
        PGPASSWORD={{ config('database.connections.pgsql.password') }} pg_dump -h {{ config('database.connections.pgsql.host') }} -p {{ config('database.connections.pgsql.port') }} -U {{ config('database.connections.pgsql.username') }} {{ config('database.connections.pgsql.database') }} > {{ base_path() . '/storage/backup/' . config('database.connections.pgsql.database') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
    @else
        rm -rf {{ base_path() . '/storage/backup/' . config('database.connections.mysql.database') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
        mysqldump -u {{ config('database.connections.mysql.username') }} -p{{ config('database.connections.mysql.password') }} {{ config('database.connections.mysql.database') }} > {{ base_path() . '/storage/backup/' . config('database.connections.mysql.database') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql' }}
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
    {{ $directories .= ' storage/backup/' . config('database.connections.mysql.database') . '_' . \Carbon\Carbon::parse(now())->format('Ymd') . '.sql ' }}
@endif


# ADD DIRECTORIES TO ZIP
cd {{ base_path() }}
zip -r -q {{ $backupFile }} {{ $directories }}
