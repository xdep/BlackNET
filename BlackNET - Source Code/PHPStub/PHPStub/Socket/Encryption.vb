Imports System.Security.Cryptography
Public Module Encryption
    Public Function RSA_Decrypt(ByVal Input As String, ByVal Key As String) As String
        Dim plain As Byte()
        Using rsa As RSACryptoServiceProvider = New RSACryptoServiceProvider(2048)
            rsa.PersistKeyInCsp = False
            rsa.FromXmlString(Key)
            Dim buffer As Byte() = Convert.FromBase64String(Input)
            plain = rsa.Decrypt(buffer, True)
        End Using
        Return System.Text.Encoding.UTF8.GetString(plain)
    End Function
End Module
