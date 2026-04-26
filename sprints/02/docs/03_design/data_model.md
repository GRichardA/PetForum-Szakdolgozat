# Data Model Documentation

## Scope
This document describes the logical data model for PetForum.

## ER diagram source
- Mermaid source: docs/03_design/diagrams/er_diagram.mmd

## Main entities

1. users
- Stores account identity and profile fields.
- Key fields: id, name, email, password, avatar, avatar_choice.

2. categories
- Event taxonomy for filtering and discovery.
- Key fields: id, name, slug, color_code.

3. events
- Community posts with time and location.
- Key fields: id, user_id, category_id, title, event_date, location, description.

4. comments
- Threaded discussion under events.
- Key fields: id, event_id, user_id, parent_id, body.

## Relationships
- A user can create many events.
- A category can classify many events.
- An event can have many comments.
- A user can write many comments.
- A comment can have many child comments (one-level reply currently used in UI).

## Integrity constraints
- events.user_id -> users.id
- events.category_id -> categories.id
- comments.event_id -> events.id
- comments.user_id -> users.id
- comments.parent_id -> comments.id (nullable)

## Notes
- Validation rules are enforced in request classes/controllers.
- Migrations are the source of truth for physical schema evolution.

## Related design docs
- UX flows and evidence matrix: docs/03_design/ux_flows.md
- API documentation: docs/03_design/api.md
- Error handling: docs/03_design/error_handling.md
