Iphotonic Project
===================================

Install project:

1. Clone repository
```
git clone git@github.com:evgeniy1204/iphotonic.git
```

2. To use that scripts as native commands add new line to $HOME/.profile:
```
PATH="bin/shortcuts:$PATH"
```
To apply changes run source `source $HOME/.profile`

3. cd iphotonic

4. Run `docker-compose up -d --build`

Go to: ENV(`DOCKER_DOMAIN`)

Example shortcuts:

`php-with-prod-env bin/console c:c` - clear cache for prod env

Install static with styles:

```
cd static
npm install
npm run build
```
