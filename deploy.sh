chmod 600 /tmp/beyond_travis
eval "$(ssh-agent -s)" # Start the ssh agent
ssh-add /tmp/beyond_travis
git remote add beyond_parallel git@git.wpengine.com:staging/korea.git # add remote for staging site
git fetch --unshallow # fetch all repo history or wpengine complain
git status # check git status
git checkout master # switch to master branch
git add wp-content/themes/beyond/*.css -f # force all compiled CSS files to be added
git commit -m "compiled assets" # commit the compiled CSS files
git push -f beyond_parallel master:master #deploy to staging site from master to master