# 2. Repository Setup Commands

## Git Init Command

### Syntax
```
git init
```

### Purpose
Creates a new Git repository in the current directory.

### Example
```
git init
```

---

## Git Clone Command

### Syntax
```
git clone <repository-url>
```

### Purpose
Creates a copy of an existing remote repository on your local machine.

### Example
```
git clone https://github.com/user/project.git
```

---

## Git Clone Branch Command

### Syntax
```
git clone --branch <branch-name> <repository-url>
```

### Purpose
Clones a repository and checks out a specific branch.

### Example
```
git clone --branch main https://github.com/user/project.git
```

---

## Git Clone Depth Command

### Syntax
```
git clone --depth <number> <repository-url>
```

### Purpose
Clones a repository with limited commit history to reduce download size.

### Example
```
git clone --depth 1 https://github.com/user/project.git
```

---

# 3. Repository Status & Inspection

## Git Status Command

### Syntax
```
git status
```

### Purpose
Shows the current state of the repository including staged, unstaged, and untracked files.

### Example
```
git status
```

---

## Git Log Command

### Syntax
```
git log
```

### Purpose
Displays the complete commit history of the repository.

### Example
```
git log
```

---

## Git Log Oneline Command

### Syntax
```
git log --oneline
```

### Purpose
Shows commit history in a short one-line format.

### Example
```
git log --oneline
```

---

## Git Log Graph Command

### Syntax
```
git log --graph
```

### Purpose
Displays commit history with a graphical representation of branches.

### Example
```
git log --graph
```

---

## Git Show Command

### Syntax
```
git show <commit-id>
```

### Purpose
Displays detailed information about a specific commit.

### Example
```
git show a1b2c3
```

---

## Git Diff Command

### Syntax
```
git diff
```

### Purpose
Shows differences between the working directory and the staging area.

### Example
```
git diff
```

---

## Git Diff Staged Command

### Syntax
```
git diff --staged
```

### Purpose
Shows differences between staged files and the last commit.

### Example
```
git diff --staged
```

---

## Git Blame Command

### Syntax
```
git blame <file>
```

### Purpose
Shows which commit and author last modified each line of a file.

### Example
```
git blame index.html
```

---

## Git Reflog Command

### Syntax
```
git reflog
```

### Purpose
Shows a log of all actions performed in the repository such as commits, resets, and checkouts.

### Example
```
git reflog
```

---

## Git Shortlog Command

### Syntax
```
git shortlog
```

### Purpose
Displays a summarized commit history grouped by author.

### Example
```
git shortlog
```

---

# 4. File Tracking Commands

## Git Add Command

### Syntax
```
git add <file>
```

### Purpose
Adds a specific file to the staging area.

### Example
```
git add index.html
```

---

## Git Add All Command

### Syntax
```
git add .
```

### Purpose
Adds all modified and new files in the current directory to the staging area.

### Example
```
git add .
```

---

## Git Add Patch Command

### Syntax
```
git add -p
```

### Purpose
Allows staging specific parts of changes interactively.

### Example
```
git add -p
```

---

## Git Restore Command

### Syntax
```
git restore <file>
```

### Purpose
Restores a file in the working directory to its last committed state.

### Example
```
git restore index.html
```

---

## Git Restore Staged Command

### Syntax
```
git restore --staged <file>
```

### Purpose
Removes a file from the staging area without deleting it.

### Example
```
git restore --staged index.html
```

---

## Git Remove Command

### Syntax
```
git rm <file>
```

### Purpose
Deletes a file from the working directory and staging area.

### Example
```
git rm index.html
```

---

## Git Move Command

### Syntax
```
git mv <old-name> <new-name>
```

### Purpose
Renames or moves a file and tracks the change in Git.

### Example
```
git mv file1.txt file2.txt
```

---

# 5. Commit Commands

## Git Commit Command

### Syntax
```
git commit
```

### Purpose
Records staged changes into the repository history.

### Example
```
git commit
```

---

## Git Commit Message Command

### Syntax
```
git commit -m "commit message"
```

### Purpose
Creates a commit with a message describing the changes.

### Example
```
git commit -m "Added login page"
```

---

## Git Commit Amend Command

### Syntax
```
git commit --amend
```

### Purpose
Modifies the most recent commit.

### Example
```
git commit --amend
```

---

## Git Commit No Edit Command

### Syntax
```
git commit --amend --no-edit
```

### Purpose
Amends the previous commit without changing its commit message.

### Example
```
git commit --amend --no-edit
```

---

# 6. Branch Management Commands

## Git Branch Command

### Syntax
```
git branch
```

### Purpose
Lists all local branches in the repository.

### Example
```
git branch
```

---

## Git Branch All Command

### Syntax
```
git branch -a
```

### Purpose
Shows both local and remote branches.

### Example
```
git branch -a
```

---

## Git Branch Delete Command

### Syntax
```
git branch -d <branch-name>
```

### Purpose
Deletes a branch safely.

### Example
```
git branch -d feature1
```

---

## Git Branch Force Delete Command

### Syntax
```
git branch -D <branch-name>
```

### Purpose
Force deletes a branch even if it is not merged.

### Example
```
git branch -D feature1
```

---

## Git Checkout Command

### Syntax
```
git checkout <branch-name>
```

### Purpose
Switches to another branch.

### Example
```
git checkout main
```

---

## Git Checkout New Branch Command

### Syntax
```
git checkout -b <branch-name>
```

### Purpose
Creates a new branch and switches to it.

### Example
```
git checkout -b feature1
```

---

## Git Switch Command

### Syntax
```
git switch <branch-name>
```

### Purpose
Switches between branches in a simpler way.

### Example
```
git switch main
```

---

## Git Switch Create Branch Command

### Syntax
```
git switch -c <branch-name>
```

### Purpose
Creates a new branch and switches to it.

### Example
```
git switch -c feature1
``` 
i am sup beside jam
