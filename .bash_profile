PS1="\u[\w]> "
export HISTSIZE=100000 SAVEHIST=100000

# aliases
alias editrc='nano ~/.bash_profile'

alias l='ls -hog'
alias la='ls -hogA'
alias ..='cd ..'
alias _='cd && clear'
alias es='cd `pwd -P`'
alias xs='cd `pwd -P`'
alias o='gnome-open'

alias proc='ps -ef | grep'

#alias gerp='grep -riHnT . -e'
#alias gerp="find . -type f | perl -lne 'print if -T;' | xargs egrep -riHnT"
alias gerp='ack-grep'

# ubuntu specific
alias update='sudo apt-get -y update && sudo apt-get -y upgrade'
alias add='sudo apt-get -y install'
alias drop='sudo apt-get -y purge && apt-get -y autoremove'
alias search='sudo apt-cache search'
alias pkgsearch='sudo dpkg -l'
alias pkgstatus='sudo dpkg -s'
alias pkgcont='sudo dpkg -L'
