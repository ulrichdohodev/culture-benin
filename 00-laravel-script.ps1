<#
PowerShell deployment script for Windows environments.
Usage:
  .\00-laravel-script.ps1            # run defaults
  .\00-laravel-script.ps1 -SkipComposer -SkipMigrate

Notes:
- Designed to be safe on Windows (skips chown/chmod).
- Checks for `resources/views` before running `php artisan view:cache`.
#>

[CmdletBinding()]
param(
    [switch]$SkipComposer,
    [switch]$SkipMigrate
)

$ErrorActionPreference = 'Stop'

function Run-External {
    param(
        [string]$Command,
        [string[]]$Args
    )
    try {
        & $Command @Args
    } catch {
        Write-Warning "Command failed: $Command $($Args -join ' ') -- $($_.Exception.Message)"
    }
}

Write-Host "Starting deployment script (PowerShell)"

if (-not $SkipComposer) {
    Write-Host "Running Composer install -- no-dev --optimize-autoloader"
    Run-External -Command 'composer' -Args @('install','--no-dev','--prefer-dist','--optimize-autoloader')
} else {
    Write-Host "Skipping Composer install (SkipComposer)"
}

if (-not $SkipMigrate) {
    Write-Host "Running migrations (php artisan migrate --force)"
    Run-External -Command 'php' -Args @('artisan','migrate','--force')
} else {
    Write-Host "Skipping migrations (SkipMigrate)"
}

Write-Host "Caching config and routes"
Run-External -Command 'php' -Args @('artisan','config:cache')
Run-External -Command 'php' -Args @('artisan','route:cache')

$viewsPath = Join-Path (Get-Location) 'resources\views'
if (Test-Path $viewsPath) {
    Write-Host "Caching views"
    Run-External -Command 'php' -Args @('artisan','view:cache')
} else {
    Write-Host "Skipping view:cache — `resources/views` not found at $viewsPath"
}

Write-Host "Creating storage symlink (artisan storage:link)"
Run-External -Command 'php' -Args @('artisan','storage:link')

# On Windows there is no chown/chmod. Provide guidance instead of failing.
if ($env:OS -eq 'Windows_NT') {
    Write-Host "Running on Windows — skipping chown/chmod. If you deploy to Linux, adjust permissions on the server."
} else {
    Write-Host "Attempting to set permissions (non-Windows)"
    Run-External -Command 'chown' -Args @('-R','www-data:www-data','storage','bootstrap/cache')
    Run-External -Command 'chmod' -Args @('-R','775','storage','bootstrap/cache')
}

Write-Host "Deployment script finished"
