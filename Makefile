start-docker:
	docker rm fullstack-challenge-20230720 || true && docker compose up -d

stop-docker:
	docker stop fullstack-challenge-20230720 && docker rm fullstack-challenge-20230720 || true

start:
	composer install && cd public && php -S localhost:8080

.PHONY: start-docker stop-docker start