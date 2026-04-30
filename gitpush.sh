#!/bin/bash

if [ "$1" = "synconly" ]; then
    # Run the synchronization command without pushing
    ssh -i /c/Users/meas/appdmc -p 65002 u1734578@appdmc.com "cd public_html/peternak_main; ./gitpull.sh; exit;"
elif [ "$1" = "commit" ]; then
    # Perform git pull, add, commit, and push with custom commit message
    git pull https://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@github.com/jokoajisf1922/peternak_main.git
    git add .
    git commit -m "$2"
    git push https://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@github.com/jokoajisf1922/peternak_main.git
    ssh -i /c/Users/meas/appdmc -p 65002 u1734578@appdmc.com "cd public_html/peternak_main; ./gitpull.sh; exit;"
else
    # Default behavior: perform git pull, add, commit, and push with default commit message
    git pull https://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@github.com/jokoajisf1922/peternak_main.git
    git add .
    git commit -m 'adding by kukuh'
    git push https://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@github.com/jokoajisf1922/peternak_main.git
    ssh -i /c/Users/meas/appdmc -p 65002 u1734578@appdmc.com "cd public_html/peternak_main; ./gitpull.sh; exit;"
fi
