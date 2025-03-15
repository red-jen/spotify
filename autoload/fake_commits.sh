
set -e


REPO_DIR="C:\Users\youco\OneDrive\Bureau\sprint 5\spotify"


cd "$REPO_DIR"


TASKS=(
  "EPIC-1: Project Foundation & Authentication"
  "WALL-1.1: Create user tables migrations"
  "WALL-1.2: Create paper type tables migrations"
  "WALL-2.1: Create registration form with role selection"
  "WALL-3.1: Create base Blade template"
  "WALL-4.1: Create paper type creation interface"
  "WALL-5.1: Create paper type listing page"
  "WALL-6.1: Create design upload form"
  "WALL-7.1: Create dashboard layout with statistics"
  "WALL-8.1: Create design catalog page with grid display"
  "WALL-9.1: Create combination interface for paper and designs"
  "WALL-10.1: Create cart data structure"
  "WALL-11.1: Set up Stripe API integration"
  "WALL-12.1: Create order history page with filtering"
  "WALL-13.1: Create star rating system"
)


generate_random_date() {
  local start_date="2025-03-15"
  local end_date="2025-05-01"
  local start_ts=$(date -d "$start_date" +%s)
  local end_ts=$(date -d "$end_date" +%s)
  local random_ts=$((RANDOM % (end_ts - start_ts + 1) + start_ts))
  date -d "@$random_ts" +"%Y-%m-%dT%H:%M:%S"
}


for TASK in "${TASKS[@]}"; do
  RANDOM_DATE=$(generate_random_date)
  echo "Fake commit for task: $TASK" > dummy_file_${TASK//[^a-zA-Z0-9]/_}.txt
  git add dummy_file_${TASK//[^a-zA-Z0-9]/_}.txt

  GIT_AUTHOR_DATE="$RANDOM_DATE" \
  GIT_COMMITTER_DATE="$RANDOM_DATE" \
  git commit -m "$TASK"
done

