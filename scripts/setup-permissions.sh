#!/bin/bash

# Groupe partagé
GROUP_NAME="webgroup"

# Liste des dossiers à créer et configurer
DIRS=(
  "public/medias/documents/identity"
  "public/medias/images/identity"
)

# Crée le groupe s’il n’existe pas
if ! getent group "$GROUP_NAME" > /dev/null; then
    echo "➕ Création du groupe $GROUP_NAME..."
    sudo groupadd "$GROUP_NAME"
else
    echo "✔️ Groupe $GROUP_NAME déjà existant."
fi

# Ajoute www-data et pirate au groupe
echo "👥 Ajout de www-data et pirate au groupe $GROUP_NAME..."
sudo usermod -a -G "$GROUP_NAME" www-data
sudo usermod -a -G "$GROUP_NAME" pirate

# Crée et configure chaque dossier
for DIR in "${DIRS[@]}"; do
    if [ ! -d "$DIR" ]; then
        echo "📁 Création du dossier $DIR..."
        sudo mkdir -p "$DIR"
    else
        echo "✔️ Le dossier $DIR existe déjà."
    fi

    echo "🛠 Application des droits sur $DIR..."
    sudo chown -R :$GROUP_NAME "$DIR"
    sudo chmod -R 775 "$DIR"
    sudo find "$DIR" -type d -exec chmod g+s {} \;
done

echo "✅ Configuration terminée pour tous les dossiers."
