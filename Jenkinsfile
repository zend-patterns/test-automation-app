pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        echo 'Build'
        sh '''if [ ! -e "${JENKINS_HOME}/composer.phar" ]; then
   wget https://getcomposer.org/composer-stable.phar -O "${JENKINS_HOME}/composer.phar"
else 
   echo "Reusing composer from [${JENKINS_HOME}]";
fi

php "${JENKINS_HOME}/composer.phar" install
'''
      }
    }

    stage('Test') {
      parallel {
        stage('PHP Unit Test') {
          post {
            always {
              echo 'Here we analyze the output from PHP unit.'
            }

          }
          steps {
            sh 'php ${WORKSPACE}/vendor/bin/phpunit ${WORKSPACE}/test'
          }
        }

        stage('PHP Fuzzing') {
          when {
            branch 'master'
          }
          steps {
            echo 'Fuzzing'
          }
        }

        stage('Integration') {
          steps {
            echo 'Integration'
          }
        }

      }
    }

    stage('Deploy') {
      steps {
        echo 'Deploy'
      }
    }

  }
}