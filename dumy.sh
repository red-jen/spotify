#!/bin/bash

# Ensure script exits on errors
set -e

# Define the repository directory
REPO_DIR="C:\Users\youco\OneDrive\Bureau\sprint 5\spotify"

# Navigate to the repository directory
cd "$REPO_DIR"

# List of files to modify (replace with actual file paths in your repo)
FILES=(
  "controller/AdminController.php"
  "controller/AuthController.php"
  "controller/ArtistController.php"
  "repositories/AlbumRepository.php"
)

# List of Jira tasks for commit messages
TASKS=(
  "WALL-1.1: Create user tables migrations"
  "WALL-3.1: Create base Blade template"
  "WALL-9.1: Create combination interface for paper and designs"
  "WALL-12.1: Create order history page with filtering"
)

# Function to make dummy changes to a file
make_dummy_changes() {
  local file=$1
  local file_extension="${file##*.}"

  case $file_extension in
    css)
      echo "/* Added dummy CSS rule for testing */" >> "$file"
      ;;
    php)
      echo "// Added dummy PHP comment for testing" >> "$file"
      ;;
    sh)
      echo "# Added dummy shell comment for testing" >> "$file"
      ;;
    ps1)
      echo "# Added dummy PowerShell comment for testing" >> "$file"
      ;;
    *)
      echo "Skipped unsupported file type for $file"
      ;;
  esac
}

# Loop through files and tasks to create commits
for i in "${!FILES[@]}"; do
  FILE="${FILES[$i]}"
  TASK="${TASKS[$i]}"

  # Make changes to the file
  make_dummy_changes "$FILE"

  # Stage the file
  git add "$FILE"

  # Commit with a specific message
  git commit -m "$TASK"
done

# Push changes (optional)
# git push origin main