#!/bin/bash

# Project name: Xampp server dashboard
# File name: /scripts/scan_git.sh

# This script scans directories to check Git status and suggests required actions.

ROOT_DIR="$1"

# Ensure a directory parameter was provided
if [ -z "$ROOT_DIR" ]; then
    echo "Usage: ./scan_git.sh path/to/root"
    exit 1
fi

# Ensure ROOT_DIR exists
if [ ! -d "$ROOT_DIR" ]; then
    echo "Error: Directory '$ROOT_DIR' does not exist!"
    exit 1
fi

# Convert Windows paths for Git Bash
if [[ "$OSTYPE" == "msys" || "$OSTYPE" == "cygwin" ]]; then
    ROOT_DIR="$(cygpath -u "$ROOT_DIR")"
fi

# Find all directories in ROOT_DIR (excluding hidden ones)
find "$ROOT_DIR" -mindepth 1 -maxdepth 1 -type d ! -name ".*" | while read -r dir; do
    dir_name=$(basename "$dir")

    # Check if it's a Git repository
    if [ -d "$dir/.git" ]; then
        cd "$dir" || continue

        status="CLEAN"
        actions=()

        # Check for untracked files (git add needed)
        if [[ -n $(git ls-files --others --exclude-standard) ]]; then
            actions+=("ADD")
        fi

        # Check for uncommitted changes (git commit needed)
        if ! git diff-index --quiet HEAD --; then
            actions+=("COMMIT")
        fi

        # Check if there are commits to push (git push needed)
        if [[ $(git cherry -v) ]]; then
            actions+=("PUSH")
        fi

        # Check if there are updates from the remote (git pull needed)
        git remote update &> /dev/null
        if ! git diff --quiet @{u}; then
            actions+=("PULL")
        fi

        # Determine final status
        if [ ${#actions[@]} -ne 0 ]; then
            status=$(IFS=,; echo "${actions[*]}")
        fi

        echo "$dir_name | GIT_REPO | $status"
    else
        echo "$dir_name | NOT_GIT_REPO"
    fi
done
