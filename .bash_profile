# GIT Prompt -----------------------------------------------------------

# http://henrik.nyh.se/2008/12/git-dirty-prompt
# http://www.simplisticcomplexity.com/2008/03/13/show-your-git-branch-name-in-your-prompt/
#   username@Machine ~/dev/dir[master]$   # clean working directory
#   username@Machine ~/dev/dir[master*]$  # dirty working directory
function parse_git_dirty {
  [[ $(git status 2> /dev/null | tail -n1) != "nothing to commit (working directory clean)" ]] && echo "*"
}
function parse_git_branch {
  git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e "s/* \(.*\)/[\1$(parse_git_dirty)]/"
}

# \n            new line
# \[\e[0;32m\]  start green
# \u            username
# \[\e[m\]      stop green
# :
# \[\e[1;34m\]  start blue
# \w            cwd
# \[\e[m\]      stop blue
# \[\e[1;36m\]  start bold cyan
# $(parse_git_branch)   current git branch
# $
# \[\e[m\]      stop cyan
# >
export PS1='\n\[\e[0;32m\]\u\[\e[m\]:\[\e[1;34m\]\w\[\e[m\]\[\e[1;36m\]$(parse_git_branch)\[\e[m\]$> '

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
