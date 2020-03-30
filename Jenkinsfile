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
          }
          stage('PHP Fuzzing') {
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
