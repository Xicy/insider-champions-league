
#  A Laravel Project for Insider: Insider Champions League

This is a [Laravel](https://laravel.com) project that use [VueJs](https://vuejs.org/) and implement Premier League Simulator.

##  Notes & caveats
  
### TODOs
#### UI
- [x] Implement Vue Tailwind
- [x] Dark mode
- [x] Create all Pages
- - [x] Dashboard
- - [x] Not found
- - [x] Tournament
- - [x] Fixture viewer
- - [x] Simulation
- [x] API calls
- [ ] Make Button Component
- [ ] Make Card Component
- [ ] Create unit tests

#### Backend
- [x] Generate DB models
- [x] Generate Api routes
- [x] Fixture Generator Implement
- [x] Tournament Coordinator Implement
- [x] Prediction Service Implement
- [ ] Validation message
- [ ] Write Unit Tests

#### Applications 
- [x] Create Docker package

###  Requirements

```json
"php": "^8.1",
"laravel/framework": "^10.0",
"node": "^18.16.0",
"npm": "^9.5.1"
```  

###  Installation

```bash
git  clone  https://github.com/Xicy/insider-champions-league
cd  insider-champions-league
composer  install
# Setup .env
php  artisan  migrate  --seed
php  artisan  serve
```

### Run with Docker

```bash
docker run -p 8080:80 ghcr.io/xicy/insider-champions-league:main
# Visit http://localhost:8080
```
