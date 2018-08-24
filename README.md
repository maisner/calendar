# Maisner / Calendar

Cloud calendars integration for Nette Framework

### Instalation
config.neon
```
extensions:
    calendar: Maisner\Calendar\DI\CalendarExtension
```
 
### Google Calendar
Required: 
- Service account auth json file - https://console.cloud.google.com/projectselector/iam-admin/serviceaccounts
- Target Google Calendar id

config.neon
```
calendar:
    wrappers:
        - googleCalendar: Maisner\Calendar\Wrapper\GoogleCalendar(serviceAccountAuth.json, 'googleCalendarId')
```