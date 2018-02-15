SELECT id, nickname FROM Users
    WHERE (nickname=? AND passwd=?)
    OR    (email=? AND passwd=?);