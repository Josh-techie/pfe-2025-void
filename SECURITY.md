# Security Policy

## Supported Versions

The following versions of the project are currently being supported with security updates:

| Sprint    | Supported          | Technologies                             |
| --------- | ------------------ | ---------------------------------------- |
| Sprint 10 | :white_check_mark: | Drupal 10, Next.js, Docker, Vactory 8    |
| Sprint 9  | :white_check_mark: | Next.js, Drupal Headless                 |
| Sprint 8  | :white_check_mark: | Vactory Profile, Drupal                  |
| Sprint 7  | :white_check_mark: | Appointment Booking System Module        |
| Sprint 6  | :x:                | Hooks, Configuration, Caching, Migration |
| Sprint 5  | :x:                | Custom Modules, Twig Templates, Forms    |
| Sprint 4  | :x:                | Basic Drupal Setup and Configuration     |
| Sprint 3  | :x:                | PHP, OOP, PDO, Framework Building        |
| Sprint 2  | :x:                | HTML/CSS/JS/Tailwind                     |
| Sprint 1  | :x:                | System Setup & Lab Configuration         |

## Reporting a Vulnerability

If you discover a security vulnerability within this project:

1. **Do not** disclose it publicly on GitHub issues
2. Send an email to [youssef.abouyahia@e-polytechnique.ma](mailto:youssef.abouyahia@e-polytechnique.ma)
3. Include details about:
   - The vulnerability type
   - How it can be reproduced
   - Potential impact
   - Suggested fix (if available)

### Response Timeline

- You will receive an acknowledgment within 48 hours
- A detailed response will be provided within 5 business days
- Security patches will be prioritized based on severity
- You'll be credited for the discovery (unless you request anonymity)

## Security Best Practices

When working with this project:

- Keep all dependencies updated
- Follow Drupal security best practices
- Use environment variables for sensitive credentials (I pushed an [`.env`](./Devops/Acaps/.env) in this repo but only for demonstration purposes only, please do not do that if you don't know what you're doing)
- Never commit sensitive information to the repository
- Review Docker configuration for secure defaults

## Special Considerations

The Capital Azure implementation in Sprint 10 requires additional security attention for production use as it contains financial-related modules and UI components.
