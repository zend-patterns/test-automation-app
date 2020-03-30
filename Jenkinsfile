pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        echo 'Build'
        sh '''if [ !-e ${JENKINS_HOME}/composer.phar ]; then
   echo "HERE"; 
fi'''
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
            echo 'PHP Unit Test'
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