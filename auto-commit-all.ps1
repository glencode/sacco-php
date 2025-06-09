$repoPath = "C:\Users\sdyac\Local Sites\sacco-php\app\public\wp-content\themes\daystar-website-fixes"  # Current project root
$branchName = "main"  # Or whatever branch you’re working on

# --- Pre-flight checks ---
# Check if Git is installed
if (-not (Get-Command git.exe -ErrorAction SilentlyContinue)) {
    Write-Error "Git is not installed or not found in PATH. Please install Git and try again."
    exit 1
}

Set-Location $repoPath -ErrorAction Stop

# Check if 'origin' remote exists
try {
    $remotes = git remote
    if ($remotes -notcontains "origin") {
        Write-Error "Git remote 'origin' is not configured for this repository. Please configure it (e.g., git remote add origin <repository_url>)."
        exit 1
    }
} catch {
    Write-Error "Failed to check Git remotes. Ensure you are in a Git repository and Git is configured correctly."
    exit 1
}
# --- End Pre-flight checks ---

Write-Host "Starting auto-commit and push for repository: $repoPath on branch: $branchName"
Write-Host "Press Ctrl+C to stop this script."

while ($true) {
    try {
        $status = git status --porcelain

        if ($status) {
            Write-Host "Changes detected. Staging, committing, and pushing..."
            git add .
            git commit -m "Auto-commit: Changes detected on $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"

            # Attempt to push and handle potential errors
            try {
                git push origin $branchName
                Write-Host "✅ Changes committed and pushed at $(Get-Date -Format 'HH:mm:ss')"
            } catch {
                Write-Error "❌ Git push failed: $($_.Exception.Message). Please check your Git credentials and network connection."
            }
        } else {
            Write-Host "No changes detected. Waiting..."
        }
    } catch {
        Write-Error "An error occurred during Git operations: $($_.Exception.Message)"
    }

    Start-Sleep -Seconds 10  # Adjust if you want faster/slower checking
}
