SELECT nickname, text
  FROM (SELECT * FROM Messages LEFT JOIN Users
    ON Users.id = Messages.user_id ORDER BY Messages.id DESC LIMIT 20) as Mesc ORDER BY Mesc.id ASC;
