export COLUMNS=80
date=$(date)
public_ip=$(curl icanhazip.com)

# Uses Ansible and outputs logs with date of run
ANSIBLE_CONFIG=./ansible.cfg ansible-playbook -i inventory.ini main.yml  --extra-vars "ssh_port=$SSH_PORT pub_key=$pub_key \
 ansible_sudo_pass=RunStr8@1! PUB_IP=$public_ip" 
