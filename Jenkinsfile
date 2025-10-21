pipeline {
      agent any
    environment {
        CONTAINER_NAME     = "${params.CONTAINER_NAME}"
        CONTAINER_IMAGE    = "${params.CONTAINER_IMAGE}"
        CONTAINER_REGISTRY = "${params.CONTAINER_REGISTRY}"
        APP_KEY_VARIABLE   = "${params.APP_KEY_VARIABLE}"
        APP_URL_VARIABLE   = "${params.APP_URL_VARIABLE}"
        API_URL_VARIABLE   = "${params.API_URL_VARIABLE}"
        REPO_USER          = "${params.REPO_USER}"
        REPO_PAT           = "${params.REPO_PAT}"
        CONTAINER_PORT     = "${params.CONTAINER_PORT}" 
    }

    stages {

        stage('Prepare manifest and env') {
            steps {
                sh '''
/bin/bash -euo pipefail <<'EOF'
sed -i "s|CONTAINER_NAME|$CONTAINER_NAME|g" manifest.yaml
sed -i "s|CONTAINER_IMAGE|$CONTAINER_IMAGE|g" manifest.yaml
sed -i "s|CONTAINER_REGISTRY|$CONTAINER_REGISTRY|g" manifest.yaml
sed -i "s|BUILD_NUMBER|$BUILD_NUMBER|g" manifest.yaml
sed -i "s|CONTAINER_PORT|$CONTAINER_PORT|g" manifest.yaml

cat > .env <<ENV_EOF
APP_KEY=$APP_KEY_VARIABLE
APP_DEBUG=true
APP_URL=$APP_URL_VARIABLE
API_URL=$API_URL_VARIABLE
ASSET_URL=$APP_URL_VARIABLE

ENV_EOF

cat manifest.yaml
EOF
                '''
            }
        }

        stage('Composer install') {
            steps { 
                sh '''
/bin/bash -euo pipefail <<'EOF'
composer install
EOF
                '''
            }
        }

        stage('Build and Push Docker Image') {
            steps {
                sh '''
/bin/bash -euo pipefail <<'EOF'
docker image build -t $CONTAINER_REGISTRY/$CONTAINER_IMAGE:$BUILD_NUMBER .
az acr login --name cwalletuat
docker image push $CONTAINER_REGISTRY/$CONTAINER_IMAGE:$BUILD_NUMBER
docker image prune -af
EOF
                '''
            }
        }

       stage('Update manifest repo') {
            steps {
                sh '''
/bin/bash -euo pipefail <<'EOF'

REPO_URL="https://$REPO_USER:$REPO_PAT@dev.azure.com/cwalletqa/CWallet-x/_git/CWalletx.Deployment.Manifests"
MANIFEST_REPO_DIR="manifest_repo"
IMAGE_TAG="${BUILD_NUMBER}"

# Remove folder if it exists, then clone
rm -rf $MANIFEST_REPO_DIR
git clone $REPO_URL $MANIFEST_REPO_DIR
cd $MANIFEST_REPO_DIR

# Update the image tag in deployment.yaml

sed -i "s|image: cwalletuat.azurecr.io/moi-uat:.*|image: cwalletuat.azurecr.io/moi-uat:${IMAGE_TAG}|g" uat-onprem/moi/deployment.yaml

# Commit and push only if changes exist
 
# Commit and push changes
echo "Committing and pushing changes..."
git config user.name "$REPO_USER"
git config user.email "jenkins@cwallet.qa"
git add .
git commit -m "Update image tag to ${IMAGE_TAG}"
git push origin main


EOF
                '''
            }
        }

    }
}
