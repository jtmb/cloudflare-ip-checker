export COLUMNS=80
date=$(date)

# Uses Ansible and outputs logs with date of run
ANSIBLE_CONFIG=./ansible.cfg ansible-playbook -i inventory.ini main.yml