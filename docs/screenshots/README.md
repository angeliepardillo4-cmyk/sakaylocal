# SakayLocal screenshots

These captures were taken from the running React app using the seeded administrator account.

| Page | Capture |
| --- | --- |
| Dashboard | [01-dashboard.png](01-dashboard.png) |
| Terminal search and management | [02-terminals.png](02-terminals.png) |
| Fare routes | [03-fare-routes.png](03-fare-routes.png) |
| Queue status workflow | [04-queue.png](04-queue.png) |

To recreate them, start the Laravel API and Vite development server, then run `node docs/capture-screenshots.mjs` from the project root. Set `EDGE_PATH`, `API_URL`, or `APP_URL` if your local setup uses different locations.
