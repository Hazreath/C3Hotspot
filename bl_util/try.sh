#!/bin/bash

date_log_rem=$(date -d "$dataset_date - 365 days" +%Y-%m-%d)
echo $date_log_rem
