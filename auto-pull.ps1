$repoPath = "C:\path\to\your\project"
$branch = "main"

Set-Location $repoPath

while ($true) {
    try {
        git fetch origin $branch
        $localHash = git rev-parse $branch
        $remoteHash = git rev-parse origin/$branch

        if ($localHash -ne $remoteHash) {
            git pull origin $branch
            Write-Host "🔄 Pulled new changes at $(Get-Date -Format 'HH:mm:ss')"
        }
    } catch {
        Write-Host "⚠️ Error pulling: $_"
    }

    Start-Sleep -Seconds 15
}
