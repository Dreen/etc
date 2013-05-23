PS1="\u[\w]> "

# aliases
alias editrc='nano ~/.bash_profile'

alias l='ls -hog'
alias la='ls -hogA'
alias ..='cd ..'
alias _='cd && clear'
alias es='cd `pwd -P`'
alias xs='cd `pwd -P`'
alias o='gnome-open'

alias update='sudo apt-get update && sudo apt-get upgrade && sudo apt-get autoremove && sudo updatedb'
alias add='sudo apt-get install'
alias drop='sudo apt-get purge'
alias search='sudo apt-cache search'

alias proc='ps -ef | grep'

aias gerpOld='grep -riHnT . -e'
alias gerp="find . -type f | perl -lne 'print if -T;' | xargs egrep -riHnT"


