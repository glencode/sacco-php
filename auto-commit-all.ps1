$repoPath = $PSScriptRoot  # Uses the directory where the script is located
$branchName = "main"  # Or whatever branch you’re working on

Set-Location $repoPath

while ($true) {
    Write-Host "Exporting database..."

    # Export database to project root
    wp db export ../db-export.sql --allow-root

    Write-Host "Staging changes for Git..."
    Set-Location ..

    git add db-export.sql
    git add "wp-content/themes/*/acf-json/"

    Write-Host "Committing and pushing..."
    git commit -m "Auto-export: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
    git push

    Write-Host "Export complete and pushed."

    Start-Sleep -Seconds 10  # Adjust if you want faster/slower checking
}
