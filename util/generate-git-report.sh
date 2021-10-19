#!/bin/bash

# usage:
#     bash util/generate-git-report.sh report-location
# outputs your changes to a .txt file
# submit that with your submission

authors=("Nova" "bigyihsuan" "pbp38")
for author in "${authors[@]}"; do
    echo "$author"
    rm "$1/$author.txt"
    echo "$1/$author.txt removed"
    commits=$(git log --author="$author" | grep ^commit | awk -F ' ' '{print $2}')
    for commit in "${commits[@]}"; do
        echo "$author $commit"
        git show "$commit" >>"$1/$author.txt"
    done
done
