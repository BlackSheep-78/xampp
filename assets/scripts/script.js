/*
    Project name: Xampp server dashboard 
    File name: /assets/scripts/script.js
*/

document.addEventListener('DOMContentLoaded', function() {
    const scanGitBtn = document.getElementById('scanGitBtn');
    const gitStatusDiv = document.getElementById('gitStatus'); // Ensure this div exists in HTML

    if (!scanGitBtn) {
        console.error("❌ scanGitBtn not found in the DOM!");
        return;
    }

    scanGitBtn.addEventListener('click', function() {
        scanGitBtn.disabled = true;
        scanGitBtn.innerText = "Scanning...";

        fetch('/xampp/scripts/scan_git.php')
            .then(response => response.json())
            .then(data => {
                console.log("Scan result:", data); // Debugging

                if (data.status === "success") {
                    if (gitStatusDiv) {
                        updateGitStatusUI(data.gitRepos);
                    } else {
                        console.error("❌ gitStatusDiv not found in the DOM!");
                    }
                } else {
                    alert("⚠️ Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                alert("An error occurred: " + error);
            })
            .finally(() => {
                scanGitBtn.disabled = false;
                scanGitBtn.innerText = "Scan Git Repositories";
            });
    });

    function updateGitStatusUI(repos) {
        if (!gitStatusDiv) return;

        gitStatusDiv.innerHTML = ""; // Clear previous results

        Object.entries(repos).forEach(([repoName, repoData]) => {
            let statusText = repoData.isRepo ? "✅ Git repository" : "❌ Not a Git repository";
            let statusColor = repoData.isRepo ? "green" : "red";
            let actionsHTML = "";

            if (repoData.isRepo && repoData.actions.length > 0) {
                actionsHTML = `<ul style="margin: 5px 0; color: orange;">`;
                repoData.actions.forEach(action => {
                    actionsHTML += `<li>⚠️ Needs: <strong>${action}</strong></li>`;
                });
                actionsHTML += `</ul>`;
            }

            gitStatusDiv.innerHTML += `
                <div style="padding: 10px; border: 1px solid #ccc; margin-bottom: 10px; border-radius: 5px;">
                    <p><strong>${repoName}:</strong> <span style="color: ${statusColor}">${statusText}</span></p>
                    ${actionsHTML}
                </div>
            `;
        });
    }
});
