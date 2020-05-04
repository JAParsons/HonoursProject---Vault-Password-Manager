# Vault Password Manager

Vault is an online password manager with a unique approach to recovering lost accounts. 

This project introduces a solution to store password data in QR codes such that they can be easily scanned in when required. A secret sharing scheme is implemented which is designed to reduce the risk of accidental loss and increase security. This allows for data to be distributed across several QR codes such that only when combined will the information be yielded and thus the passwords recovered. 


# Secret-sharing Scheme

The workings of the secret-sharing scheme are as follows:

-   A user enters some sensitive information such as a password or encryption key which they wish to backup.
    
-   This information is distributed across a number of QR codes like so.
    
-   In the event that the information needs to be recovered, a majority of the shares can be brought together in order to reconstruct the original data.


# Cryptographic Components

The second project phase required a more complex design with the addition of several cryptographic components.

The account password is what the user uses to login to the application and is the only password they need remember.

The KEK (key encryption key) is derived from the account password upon login and is used purely to secure the master encryption key. The reason this is needed is that it avoids invalidating the QR backups should the account password be changed.

The master key is what is backed up in the QR codes and is responsible for encrypting and decrypting the stored passwords.

The stored passwords are simply the passwords a user wishes to manage.

# Installation 

This project was developed with the Laravel PHP framework. Please refer to the documentation regarding how to setup your environment: [https://laravel.com/docs/7.x/installation](https://laravel.com/docs/7.x/installation)

Proceeding this, clone the repository into your development environment.
