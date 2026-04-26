# Top 3 User Journeys

Date: 2026-04-25

## Journey 1 - New user creates first event

Persona:
- A local organizer who wants to publish a new event quickly.

Entry point:
- Deep link to S01 (/register), then auto-login or manual login.

Steps:
1. S01 - User registers with name, email, password.
   - System response: account created or validation errors.
   - Error branch: duplicate email blocks registration.
2. S02 - User sees event list and chooses create action.
   - System response: navigates to S03.
3. S03 - User fills event fields and submits.
   - System response: event saved, redirect to S06 or S04.
   - Error branch: missing title or invalid category shows field-level errors.
4. S04 - User opens event details and confirms content.
   - Success criterion: event visible with correct metadata.

Estimated duration:
- 60 to 120 seconds, around 8 to 12 interactions.

## Journey 2 - Returning user comments on an event

Persona:
- A community member who wants to react to a listed event.

Entry point:
- S02 from homepage (/events).

Steps:
1. S02 - User searches/selects event card.
   - System response: opens S04.
2. S04 - User writes comment and submits.
   - System response: comment appears in thread.
   - Error branch: empty comment is rejected.
3. S04 - User replies to an existing comment.
   - System response: reply is nested under parent comment.
   - Error branch: invalid parent id rejected.

Success criterion:
- Comment and optional reply are both visible and tied to user.

Estimated duration:
- 30 to 75 seconds, around 4 to 7 interactions.

## Journey 3 - User updates profile and avatar

Persona:
- Authenticated user updating identity and profile image.

Entry point:
- Profile link to S05 (/profile).

Steps:
1. S05 - User edits display name/email and optionally password.
   - System response: validation or save success.
2. S05 - User uploads avatar or chooses default avatar.
   - System response: image processed and profile updated.
   - Error branch: invalid file type or size fails.
3. S02 - User returns to main screen and verifies avatar in UI.

Success criterion:
- Updated profile data and avatar are shown consistently.

Estimated duration:
- 45 to 90 seconds, around 5 to 9 interactions.
