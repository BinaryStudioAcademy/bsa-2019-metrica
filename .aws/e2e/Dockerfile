FROM lenchv/metrica-e2e:latest

ARG UID=1000
ARG GID=1000

RUN groupadd --gid 1000 user \
  && useradd --uid 1000 --gid user --shell /bin/bash --create-home user

USER user

ENTRYPOINT ["tail", "-f", "/dev/null"]
