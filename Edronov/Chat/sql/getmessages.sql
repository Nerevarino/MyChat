SELECT nickname, text
  FROM Messages LEFT JOIN Users
    ON Users.id = Messages.user_id ORDER BY Messages.id ASC LIMIT 20;