API contracts (rövid)

GET /events
- Leírás: események listázása (query: category, search)
- Válasz: JSON tömb esemény objektumokkal (id,title,description,event_date,location,category,user)

GET /events/{id}
- Leírás: egy esemény részletei (kommentekkel)
- Válasz: esemény objektum + comments tömb

POST /events
- Leírás: új esemény létrehozása (auth)
- Body (application/x-www-form-urlencoded vagy JSON): title, event_date, location, description, category_id
- Válasz: 201 Created + létrehozott esemény objektum vagy 422 validációs hiba

POST /events/{event}/comments
- Leírás: hozzászólás létrehozása az eseményhez (auth)
- Body: body, parent_id (opcionális)
- Válasz: 302 redirect a web UI-n (vagy 201 JSON API esetén)

POST /profile (PUT /profile)
- Profil frissítés: name,email,password(optional),avatar (file) vagy avatar_choice

GET /user-avatars/{filename}
- Fájl kiszolgálás a feltöltött avatarokhoz (képek)

Megjegyzés: ez a projekt alapvetően blade/web app; ha később API-first megközelítést szeretnél, érdemes explicit JSON API végpontokat létrehozni és dokumentálni a response formátumokat (például OpenAPI/Swagger használatával).
