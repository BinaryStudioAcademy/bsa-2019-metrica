FROM lenchv/metrica-e2e:latest

ARG UID=1000
ARG GID=1000

RUN groupadd --gid $GID user \
  && useradd --uid $UID --gid user --shell /bin/bash --create-home user

USER user

ENTRYPOINT ["tail", "-f", "/dev/null"]
