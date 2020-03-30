pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        echo 'Build'
      }
    }

    stage('Tests') {
      parallel {
          stage('PHP Unit Test') {
              steps {
                  echo "PHP Unit Test"
              }
              post {
                  always {
                      echo 'Here we analyze the output from PHP unit.'
                  }
              }
          }
          stage('PHP Fuzzing') {
              when {
                branch 'master'
              }
              steps {
                  echo "Fuzzing"
              }
          }
          stage('Integration') {
                steps {
                    echo "Integration"
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