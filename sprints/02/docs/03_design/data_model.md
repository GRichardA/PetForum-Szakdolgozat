# Data Model Documentation

## Scope
This document describes the logical data model for PetForum.

## ER diagram source
- Mermaid source: docs/03_design/diagrams/er_diagram.mmd

## Main entities

1. users
- Stores account identity and profile fields.
- Key fields: id, name, email, password, avatar, avatar_choice, is_admin (boolean, default false).

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
- events.user_id -> users.id (cascade on delete)
- events.category_id -> categories.id
- comments.event_id -> events.id (cascade on delete)
- comments.user_id -> users.id (cascade on delete)
- comments.parent_id -> comments.id (nullable, cascade on delete)

## Cascade delete behavior
- Deleting a user cascades to their events and comments.
- Deleting an event cascades to all its comments.
- Deleting a parent comment cascades to all child comments (recursive in application layer via Comment::boot()).
- Deleting a category allows orphaning events (no cascade), as per business logic.

## Notes
- Validation rules are enforced in request classes/controllers.
- Migrations are the source of truth for physical schema evolution.
- Comment deletion is handled with recursive cascade via Laravel's static boot() hook in Comment model.
- Authorization is checked at the application layer (canBeDeletedBy method) before deletion.

## Authorization and roles
- users.is_admin: Admin users have elevated permissions.
  - Can delete any event (not just own).
  - Can delete any comment (not just own).
  - Can manage categories.
  - Can moderate events in admin panel.
- Regular users can only delete their own events and comments.
- Authorization is checked at the application layer (canBeDeletedBy method) before deletion.

## Related design docs
- UX flows and evidence matrix: docs/03_design/ux_flows.md
- API documentation: docs/03_design/api.md
- Error handling: docs/03_design/error_handling.md
