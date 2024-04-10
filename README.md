# Civil Air Patrol Emergency Management System (CAP EMS)
Hello, and welcome to the CAP EMS Readme! My name is 2dLt Tayler (TJ) Porter, and I am a member of the Missouri Wing.  I created the CAP EMS after being an MRO for the Wing ICP during a state-wide Search and Rescue Exercise.  During this exercise, I noticed it is easy to miss when one of the ten active sorties misses a check-in.  CAP EMS is used to track Air, Ground, and sUAS sorties and provide an easy-to-use dashboard that will provide a common operating picture for the IC, AOBD, GBD, CUL, and other stakeholders.

## Features
### Missed Checkin Alerts
The most useful feature, and the original purpose of CAP EMS, is to notify the CUL and MROs when a check-in is missed.  After 30 minutes of no recorded check-ins from a sortie, the sortie will be highlighted yellow. This is to show that sortie is due for check-in but is not yet cause for concern. After 35 minutes of no recorded check-ins from a sortie, the sortie will be highlighted red. This is to show that sortie is overdue for check-in and that MROs should attempt to make contact and request a sitrep.  These times can be customized by the Web Security Admin maintaining the system. A few possibilities are: 
  * warning and alarm after 60 and 65 minutes;
  * sorties go straight to red at 30 minutes;
  * and sorties go red at 45 minutes.

### Common Operating Picture
All relevant information about a sortie is presented in an easy-to-read table that can be edited with a few clicks of a button.  Each type of sortie tracks specialized information that is relevant to its sortie type, however here are the common columns:
  * Mission Number
  * Sortie Number
  * Tasking
  * Status
  * Location
  * Last Checkin

Additional ground sortie columns:
  * COV
  * Driver
  * GTL
  * Number of Passengers

Additional air sortie columns:
  * Aircraft Callsign
  * MP
  * MO
  * MS/AP

Additional sUAS sortie columns:
  * Ground Team attached to
  * MP

### Audit Trail / Sortie History
All changes to a sortie on the status board are logged in the Audit Trail. The Audit Trail will show you the exact time that a change was made and what was changed.  This audit log is preserved for history (unless specifically deleted by the WSA) and can be referenced after the mission for an After Actions Review, or for entering in missed Comm Log entries into WIMRS.

### Customizable
CAP EMS has basic customization. CAP EMS was originally designed for Missouri Wing, however by changing just two files, you can change the branding to your wing or unit insignia.  You can also change the alert times to any value that you see fit.

## Installation 
CAP EMS is easy to install for an experienced IT Officer.  It was developed on Ubuntu Server 22.04.4 LTS with Apache 2.4.52, PHP 8.1.2, MySQL 8.0.36, and PHPMyAdmin 5.1.1 hosted by Azure with a virtual machine size of `Standard B2s` (2 vCPUs, 4 GiB RAM) which seem to be the minimum requirement for smooth operation.  Please see the setup folder for the Apache site config and the SQL necessary to create the database and all of the required tables.  If you require assistance, feel free to contact me via CAP email.
