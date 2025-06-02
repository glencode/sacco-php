$repoPath = "C:\Users\sdyac\Local Sites\sacco-php\app\public\wp-content\themes\sacco-php"  # Current project root
$branchName = "main"  # Or whatever branch you’re working on

Set-Location $repoPath

while ($true) {
    $status = git status --porcelain

    if ($status) {
        git add .
        git commit -m "Auto-commit: Changes detected on $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
        git push origin $branchName
        Write-Host "✅ Changes committed and pushed at $(Get-Date -Format 'HH:mm:ss')"
    }

    Start-Sleep -Seconds 10  # Adjust if you want faster/slower checking
}
