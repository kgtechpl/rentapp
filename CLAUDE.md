# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

RENTAPP is a PHP rental application. The project is in early setup; source code has not been scaffolded yet.

## Environment

- **PHP**: 8.1 (via Laragon at `C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe`)
- **Local dev server**: Laragon (Apache/Nginx + MySQL bundled)
- **Deployment**: SFTP auto-upload to `s30.mydevil.net`

## PHP Tooling (configured in PhpStorm)

| Tool | Purpose |
|------|---------|
| PHP CS Fixer | Code style fixing |
| PHP CodeSniffer | Style linting |
| Mess Detector (PHPMD) | Code smell detection |
| PHPStan | Static analysis |
| Psalm | Static analysis |

Run linters from the project root once installed via Composer:

```bash
vendor/bin/php-cs-fixer fix
vendor/bin/phpcs
vendor/bin/phpmd src/ text cleancode
vendor/bin/phpstan analyse src/
vendor/bin/psalm
```

## GitHub Copilot Instructions

If `.github/instructions/` files exist, they contain per-task Copilot instructions and should be kept in sync with this file.
