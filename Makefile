start:
	docker rm fullstack-challenge-20230720 || true && docker compose up -d

stop:
	docker stop fullstack-challenge-20230720 && docker rm fullstack-challenge-20230720 || true

.PHONY: start stop