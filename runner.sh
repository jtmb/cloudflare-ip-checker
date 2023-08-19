export COLUMNS=80
date=$(date)

# Uses Ansible and outputs logs with date of run
ANSIBLE_CONFIG=./ansible.cfg ansible-playbook -i inventory.ini main.yml  --extra-vars "ssh_port=$SSH_PORT pub_key=$pub_key \
 ansible_sudo_pass=RunStr8@1! PUB_IP=$public_ip \
 cf_key=$CF_KEY cf_zone_id=$CF_ZONE_ID discord_webhook=$DISCORD_WEBHOOK a_name_record=$A_NAME_RECORD" 