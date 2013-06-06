#!/bin/bash -x

git add -A 
git commit -a -m "$*"
git push
